@php use Illuminate\Support\Str; @endphp
@extends('layouts.adminlte')

@section('content')
<div class="container py-4">
    @if(isset($editUser) || request()->routeIs('admin.users.create'))
        {{-- Form Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark-brown">
                <i class="fas fa-user-shield me-2"></i>
                {{ isset($editUser) ? 'Edit Resepsionis' : 'Tambah Resepsionis' }}
            </h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark-brown">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any()))
            <div class="alert alert-danger shadow-sm rounded-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Oops!</strong> Ada kesalahan:
                </div>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-gold text-dark rounded-top-4">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-user-edit me-2"></i>
                    Formulir Resepsionis
                </h5>
            </div>
            <div class="card-body px-4 py-4 bg-cream">
                <form 
                    action="{{ isset($editUser) ? route('admin.users.update', $editUser->id) : route('admin.users.store') }}" 
                    method="POST" enctype="multipart/form-data"
                >
                    @csrf
                    @if(isset($editUser)) @method('PUT') @endif

                    <div class="row g-4">
                        <div class="col-md-8">
                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-dark-brown">
                                    <i class="fas fa-user me-1"></i> Nama Lengkap
                                </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $editUser->name ?? '') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-dark-brown">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $editUser->email ?? '') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold text-dark-brown">
                                    <i class="fas fa-phone me-1"></i> Nomor Telepon
                                </label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $editUser->phone ?? '') }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold text-dark-brown">
                                    <i class="fas fa-map-marker-alt me-1"></i> Alamat
                                </label>
                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $editUser->address ?? '') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label fw-semibold text-dark-brown">
                                    <i class="fas fa-lock me-1"></i>
                                    {{ isset($editUser) ? 'Password Baru' : 'Password' }}
                                </label>
                                <input type="password" name="password" id="passwordInput" 
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ isset($editUser) ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}"
                                    {{ isset($editUser) ? '' : 'required' }}>
                                <span class="position-absolute end-0 top-50 mt-1 me-3 toggle-password" 
                                      style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            {{-- Foto --}}
                            <div class="mb-3">
                                <label for="photo" class="form-label fw-semibold text-dark-brown">
                                    <i class="fas fa-camera me-1"></i> Foto Profil
                                </label>
                                <input type="file" name="photo" id="photoInput" 
                                       class="form-control @error('photo') is-invalid @enderror" 
                                       accept="image/*">
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="text-center mt-3">
                                <img id="photoPreview" 
                                     src="{{ isset($editUser) && $editUser->photo ? asset('storage/photos/' . $editUser->photo) : asset('img/default-avatar.png') }}" 
                                     alt="Foto Resepsionis" 
                                     class="rounded-circle shadow border border-gold"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-gold shadow-sm">
                            <i class="fas fa-save me-1"></i> {{ isset($editUser) ? 'Update Data' : 'Simpan Resepsionis' }}
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark-brown">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    @else
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark-brown mb-0">
                <i class="fas fa-user-shield me-2"></i>
                Daftar Resepsionis
            </h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-gold shadow-sm">
                <i class="fas fa-user-plus me-1"></i> Tambah Resepsionis
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Tabel --}}
        @if($users->isEmpty()))
            <div class="text-center text-muted py-5 bg-light-gold rounded-3">
                <i class="fas fa-user-friends fa-3x mb-3 text-gold"></i>
                <h5 class="text-dark-brown">Belum ada data resepsionis</h5>
                <p class="mb-0">Klik tombol "Tambah Resepsionis" untuk menambahkan data baru</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle shadow-sm border rounded overflow-hidden">
                    <thead class="table-dark-brown text-white">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Password</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $i => $user)
                            <tr class="{{ $loop->odd ? 'bg-light-gold' : 'bg-white' }}">
                                <td class="fw-semibold">{{ $i + 1 }}</td>
                                <td class="text-center">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/photos/' . $user->photo) }}" 
                                             alt="Foto" 
                                             width="50" height="50"
                                             class="rounded-circle shadow-sm border border-gold"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="bg-light-gold rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-dark-brown"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ Str::limit($user->address, 20) }}</td>
                                <td><code>{{ $user->password_plain ?? '••••••' }}</code></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus {{ $user->name }}?')"
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>

{{-- Custom CSS --}}
<style>
    /* Warna Utama */
    .bg-gold {
        background: linear-gradient(45deg, #C9A227, #D4AF37) !important;
    }
    .bg-cream {
        background-color: #FAF6F0 !important;
    }
    .text-dark-brown {
        color: #4E342E !important;
    }
    .bg-dark-brown {
        background-color: #4E342E !important;
    }
    .table-dark-brown {
        background: linear-gradient(45deg, #3E2723, #5D4037);
        color: white;
    }
    
    /* Warna Sekunder */
    .bg-light-gold {
        background-color: rgba(201, 162, 39, 0.15) !important;
    }
    .text-gold {
        color: #C9A227 !important;
    }
    .border-gold {
        border-color: #C9A227 !important;
    }
    
    /* Tombol */
    .btn-outline-dark-brown {
        color: #4E342E;
        border: 1px solid #4E342E;
        background-color: transparent;
    }
    .btn-outline-dark-brown:hover {
        background-color: #4E342E;
        color: white;
    }
    
    .btn-gold {
        background: linear-gradient(45deg, #C9A227, #D4AF37);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gold:hover {
        background: linear-gradient(45deg, #B7931A, #C9A227);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Form */
    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.25rem rgba(201, 162, 39, 0.25);
    }
    
    /* Animasi */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    .pulse-animation {
        animation: pulse 1.5s infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('passwordInput');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    }

    // Photo preview
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection