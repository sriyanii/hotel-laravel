@extends('layouts.adminlte')

@section('content')
<div class="container py-4">
    @if(isset($editUser) || request()->routeIs('admin.users.create'))
        {{-- Form Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-pink">{{ isset($editUser) ? 'Edit Resepsionis' : 'Tambah Resepsionis' }}</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-pink">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <strong>Oops!</strong> Ada kesalahan:
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body px-4 py-4">
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
                                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $editUser->name ?? '') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $editUser->email ?? '') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    {{ isset($editUser) ? 'Password Baru' : 'Password' }}
                                </label>
                                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ isset($editUser) ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}"
                                    {{ isset($editUser) ? '' : 'required' }}>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            {{-- Foto --}}
                            <div class="mb-3">
                                <label for="photo" class="form-label fw-semibold">Foto (Opsional)</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @if(isset($editUser))
                                <div class="text-center mt-3">
                                    <img src="{{ $editUser->photo ? asset('storage/photos/' . $editUser->photo) : asset('img/default-avatar.png') }}" 
                                         alt="Foto Resepsionis" 
                                         class="rounded-circle shadow border border-pink"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-pink shadow-sm">
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
            <h3 class="fw-bold text-pink mb-0">Daftar Resepsionis</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-pink shadow-sm">
                <i class="fas fa-user-plus me-1"></i> Tambah Resepsionis
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        {{-- Tabel --}}
        @if($users->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="fas fa-user-friends fa-2x mb-3"></i><br>
                Belum ada data resepsionis.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle shadow-sm border rounded bg-white overflow-hidden">
                    <thead class="bg-pink text-white" style="position: sticky; top: 0;">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="text-center">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/photos/' . $user->photo) }}" 
                                             alt="Foto" 
                                             width="50" height="50"
                                             class="rounded-circle shadow-sm border border-2"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><code>{{ $user->password_plain ?? '••••••' }}</code></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus {{ $user->name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination opsional --}}
                {{-- <div class="mt-3">{{ $users->links() }}</div> --}}
            </div>
        @endif
    @endif
</div>

{{-- Custom CSS --}}
<style>
    .text-pink {
        color: #d63384 !important;
    }
    .btn-pink {
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
    }
    .btn-pink:hover {
        background-color: #f1b0b7;
        color: #842029;
    }
    .btn-outline-pink {
        border: 1px solid #f8d7da;
        color: #d63384;
    }
    .btn-outline-pink:hover {
        background-color: #f8d7da;
        color: #842029;
    }
    .bg-pink {
        background-color: #f8d7da !important;
    }
    .border-pink {
        border-color: #f8d7da !important;
    }
</style>
@endsection
