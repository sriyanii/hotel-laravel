@extends('layouts.adminlte')

@section('content')
<div class="container py-4">
    @if(isset($editUser) || request()->routeIs('admin.users.create'))
        {{-- Form Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">
                <i class="fas fa-user-shield me-2"></i>
                {{ isset($editUser) ? 'Edit Resepsionis' : 'Tambah Resepsionis' }}
            </h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
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
        <div class="card border-0 shadow-lg rounded-4 bg-light">
            <div class="card-header bg-dark text-light rounded-top-4">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-user-edit me-2"></i>
                    Formulir Resepsionis
                </h5>
            </div>
            <div class="card-body px-4 py-4 bg-light">
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
                                <label for="name" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-user me-1"></i> Nama Lengkap
                                </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $editUser->name ?? '') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $editUser->email ?? '') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-phone me-1"></i> Nomor Telepon
                                </label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $editUser->phone ?? '') }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-map-marker-alt me-1"></i> Alamat
                                </label>
                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $editUser->address ?? '') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- {{-- Role --}}
                            <div class="mb-3">
                                <label for="role" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-users me-1"></i> Role
                                </label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="resepsionis" {{ (old('role', $editUser->role ?? '') == 'resepsionis') ? 'selected' : '' }}>Resepsionis</option>
                                    <option value="admin" {{ (old('role', $editUser->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div> -->

                            {{-- Password --}}
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label fw-semibold text-dark">
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
                                <label for="photo" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-camera me-1"></i> Foto Profil
                                </label>
                                <input type="file" name="photo" id="photoInput" 
                                       class="form-control @error('photo') is-invalid @enderror" 
                                       accept="image/*">
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="text-center mt-3">
                                <img id="photoPreview" 
                                     src="{{ isset($editUser) && $editUser->photo ? asset('imge/' . $editUser->photo) : asset('img/default-avatar.png') }}" 
                                     alt="Foto Resepsionis" 
                                     class="rounded-circle shadow border border-gray"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="fas fa-save me-1"></i> {{ isset($editUser) ? 'Update Data' : 'Simpan Resepsionis' }}
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    @else
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">
                <i class="fas fa-user-shield me-2"></i>
                Daftar Resepsionis
            </h3>
            <a href="{{ route('admin.users.create') }}" class="btn shadow-sm text-white" style="background: #5e5e5e">
                <i class="fas fa-user-plus me-1 text-white"></i> Tambah Resepsionis
            </a>
        </div>

        {{-- Search Form --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama, Email, atau Telepon" value="{{ request('search') }}">
                <button type="submit" class="btn btn-dark ms-2">
                    <i class="fas fa-search"></i> Cari
                </button>
                {{-- Reset Search --}}
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Tabel --}}
        @if($users->isEmpty())
            <div class="text-center text-muted py-5 bg-light rounded-3">
                <i class="fas fa-user-friends fa-3x mb-3 text-primary"></i>
                <h5 class="text-dark">Belum ada data resepsionis</h5>
                <p class="mb-0">Klik tombol "Tambah Resepsionis" untuk menambahkan data baru</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle shadow-sm border rounded overflow-hidden">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <!-- <th>Role</th> -->
                            <th>Password</th>
                            <th class="text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('imge/'.$user->photo) }}" alt="Foto" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->address }}</td>
                                <!-- <td>{{ ucfirst($user->role) }}</td> -->
                                <td>********</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning rounded-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info rounded-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($users->hasPages())
                <div class="d-flex justify-content-end my-4" style="margin-right: 30px;">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('passwordInput');
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }

        // Foto Preview
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    photoPreview.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
